# Laravel Letexto Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/juvpengele/laravel-letexto.svg?style=flat-square)](https://packagist.org/packages/juvpengele/laravel-letexto)
[![Total Downloads](https://img.shields.io/packagist/dt/juvpengele/laravel-letexto.svg?style=flat-square)](https://packagist.org/packages/juvpengele/laravel-letexto)

This is a package to integration the web application [Letexto](http://letexto.com) in a laravel application.


## Installation

You can install the package via composer:

```bash
    composer require juvpengele/laravel-letexto
```

You must add your API Key in the .env file
```dotenv
    LETEXTO_TOKEN=my-api-token
```

## Features

All resources fetched are an instance of Letexto\Http\Response.

### Campaigns

- To fetch all campaigns
    
    ``` php
         use Letexto\Campaign;
         
         $campaigns = Campaign::fetchAll();
    ```

- Filter campaigns to fetch
    
    ```php
       use Letexto\Campaign;
  
       $campaigns = Campaign::filterBy(['status' => 'sent'])->fetchAll();
    ```

- Create a campaign
    
    To create a campaign, we have to add some attributes that are required by the application using a fluent interface.
    Here is an example of how a campaign can be sent.
        
    ```php
        use Letexto\Campaign;
  
        $campaign = Campaign::create(['name' => 'My campaign'])
                ->withAttributes([
                    'sender' => 'John Doe', // Add one of your application senders
                    'recipientSource' => 'custom',
                    'campaignType' => 'SIMPLE',
                    'responseUrl' => 'https://mywebsite.com/campaign-feedback', // Add your response url callback    
                ])
                ->to([
                    ['phone' => '22501010101']
                ])
                ->withMessage('Hello world')
                ->send();
    ```

### Messages of a campaign
     
- To get the messages of a campaign, we must first fetch the campaign as an instance of the Campaign class.
 In this way, we can fetch messages of this campaign.

     ```php
          use Letexto\Campaign;
    
          $campaign = Campaign::find("f9r4gegetg49getg98e49t");
          $messages = $campaign->getMessages();
     ```


### Volume

- We can fetch the volume of a user.
    ```php
          use Letexto\Volume;
          
          $volume = Volume::fetch();
    ```

## Credits

- [Juvenal Pengele](https://github.com/juvpengele)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
