# Laravel Letexto Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/juvpengele/laravel-letexto.svg?style=flat-square)](https://packagist.org/packages/juvpengele/laravel-letexto)
[![Total Downloads](https://img.shields.io/packagist/dt/juvpengele/laravel-letexto.svg?style=flat-square)](https://packagist.org/packages/juvpengele/laravel-letexto)

This is a package that integrate the web application [Letexto](http://letexto.com) API in a laravel application.


## Installation

You can install the package via composer:

```bash
  $ composer require juvpengele/laravel-letexto
```

You must add your API Key in the .env file
```dotenv
  .env
	  
  LETEXTO_TOKEN=my-api-token
```

## Features

All resources fetched are an instance of Letexto\Http\Response.

### Campaigns

- To fetch all campaigns
    
    ``` php
         use Letexto\Resources\Campaign;
         
         $campaigns = Campaign::fetchAll();
    ```

- Filter campaigns to fetch
    
    ```php
        use Letexto\Resources\Campaign;
  
       $campaigns = Campaign::filterBy(['status' => 'sent'])->fetchAll();

    ```

- Create a campaign
    
    To create a campaign, we have to add some attributes that are required by the application using a fluent interface.
    Here is an example of how a campaign can be sent.
        
    ```php
        use Letexto\Resources\Campaign;
  
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

- Messages of a campaign
     
    To get the messages of a campaign, we must first fetch the campaign as an instance of the Campaign class.
 In this way, we can fetch messages of this campaign.

     ```php
      use Letexto\Resources\Campaign;

      $campaign = Campaign::find("f9r4gegetg49getg98e49t");
      $messages = $campaign->getMessages();
     ```



### Messages

- To fetch all messages
    
    ``` php
         use Letexto\Resources\Message;
         
         $messages = Message::fetchAll();
    ```

- Filter messages to fetch
    
    ```php
       use Letexto\Resources\Message;
  
       $messages = Message::filterBy(['sender' => 'John Doe'])->fetchAll();
    ```

- To fetch statistics of messages
    
   ```php
        use Letexto\Resources\Message    
  
        $statistics = Message::getStatistics();
    ```



### Volume

- We can retrieve the volume of a user.

    ```php
          use Letexto\Resources\Volume;
          
          $volume = Volume::retrieve();
    ```

## Credits

- [Juvenal Pengele](https://github.com/juvpengele)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
