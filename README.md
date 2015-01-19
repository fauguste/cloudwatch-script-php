[![Build Status](https://travis-ci.org/fauguste/cloudwatch-script-php.svg)](https://travis-ci.org/fauguste/cloudwatch-script-php)

# Amazon CloudWatch Monitoring Scripts for EC2 Instance

This project provide some scripts in order to monitor your EC2 instances with Cloud Watch.
You can add some script on own script in the plugin directory. 

## Prerequite

This library are require for this project :
```
php5-cli, php5-curl
```

## Configuration

Add your key and secret in the config file.
Add the metrics you need execute in the config file.

## Usage

Send metrics to Cloud Watch (Run every 5 minutes)`

```
php -f metrics.php
```

Create alarme in Cloud Watch (Run one time)
```
    php -f alarmes.php
```

## Plugins 

| Name | Description          |
| ------------- | ----------- |
| Solr      | Monitoring ping solr URL |

## License

This application licensed by Apache License Version 2.0.
