# MQ Client for Akeneo
A Message Queue bundle for the Akeneo PIM

## Principle

This simple bundle allows to push a message to a Google Cloud Pub/Sub topic each time a product is modified.

## Use case

Combined with other services orchestrated from an ESB, this allows to asynchronously process changes (BLOB for examples) and push them back to the PIM or to any other application (catalog, etc)

We use this in a BIM environment to parse ArchiCAD 3D .gsm model files and inject the PIM data to generate up to date versions of 3D furniture libraries.

## Installation

From your PIM project root folder, clone the repository:

`git clone https://github.com/bimbus/mq-client-akeneo src/Bimbus`

Then add the needed dependencies:

`composer require google/cloud-pubsub`

Edit the `app/AppKernel.php` file to reflect this:

```php
    protected function registerProjectBundles()
    {
        return [
          new Bimbus\Bundle\MQBundle\BimbusMQBundle(),
        ];
    }
 ```

Empty your cache: 

`bin/console cache:clear --env=prod`

## Google Cloud Pub/Sub

Select or create the project. If this is a creation, activate the Pub/sub API.

### Create a service account

- Select the `IAM & admin > Service accounts` menu item then click on **CREATE SERVICE ACCOUNT**.
- Type in a name for the new service account (eg. akeneo-mq) and check the *Furnish a new private key* checkbox.
- Click on "CREATE", the JSON credentials file should be downloaded automatically.
- Rename the downloaded file to `gcp-credentials.json` and put it in the `src/Bimbus/config` folder.

### Create a topic

- Go to the `Pub/Sub > Topics` menu and then click on **CREATE TOPIC**.
- On the next screen, select the newly created topic.
- Then, type in the name of the new service account your just created and give it the "Pub/Sub Publisher" Role.

### Create a subscription

- Return to the `Pub/Sub > Topics` menu.
- Click the button at the end of the created topic line and select *New subscription*.
- Enter a name and click on create.

## Bundle configuration

- Move into the `src/Bimbus/Bundle/MQBundle/Resources/config/` folder.
- Copy the `parameters.yml.dist` to `parameters.yml`.
- Edit the `parameters.yml` file to fill in the `gcp.pubsub.project` and `gcp.pubsub.topic` keys:

```yaml
parameters:
    gcp.pubsub.project: '<<gcp-project-id>>'
    gcp.pubsub.topic: '<<last-part-of-topic>>'
    gcp.pubsub.credentials: '%kernel.project_dir%/src/Bimbus/config/gcp-credentials.json'
```

## Test everything

- Open the Akeneo UI and edit a product to check that saving works fine.
- Use the `gcloud` CLI to check that the message as been pushed to the topic:

```bash
gcloud config set project <<gcp-project-id>>
gcloud pubsub subscriptions pull <<subscription-name>>
```
