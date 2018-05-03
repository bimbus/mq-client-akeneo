# mq-client-akeneo
A Message Queue bundle for the Akeneo PIM

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

- Select the `IAM & admin > Service accounts` menu item then click on "CREATE SERVICE ACCOUNT".
- Type in a name for the new service account (eg. akeneo-mq) and check the "Furnish a new private key" checkbox.
- Click on "CREATE", the JSON credentials file should be downloaded automatically.
- Rename the downloaded file to `gcp-credentials.json` and put it in the `src/Bimbus/config` folder.

### Create a topic

- Go to the `Pub/Sub > Topics` menu and then click on "CREATE TOPIC".
- On the next screen, select the newly created topic.
- Then, type in the name of the new service account your just created and give it the "Pub/Sub Publisher" Role.


## Bundle configuration

YTC
