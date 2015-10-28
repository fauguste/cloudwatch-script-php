[![Build Status](https://travis-ci.org/fauguste/cloudwatch-script-php.svg)](https://travis-ci.org/fauguste/cloudwatch-script-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fauguste/cloudwatch-script-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fauguste/cloudwatch-script-php/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/482807e9-f93b-48f0-8dd5-51d3cc1b673f/mini.png)](https://insight.sensiolabs.com/projects/482807e9-f93b-48f0-8dd5-51d3cc1b673f)
[![Code Climate](https://codeclimate.com/github/fauguste/cloudwatch-script-php/badges/gpa.svg)](https://codeclimate.com/github/fauguste/cloudwatch-script-php)
[![Test Coverage](https://codeclimate.com/github/fauguste/cloudwatch-script-php/badges/coverage.svg)](https://codeclimate.com/github/fauguste/cloudwatch-script-php)
# Amazon CloudWatch Monitoring Scripts for EC2 Instance

This project provide some scripts in order to monitor your EC2 instances with Cloud Watch.
You can add some script on own script in the plugin directory. 

## Prerequite

This library are require for this project :
```
php5-cli, php5-curl
```

## Configuration

Autorize this policy :
````
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Sid": "Stmt1446055544000",
            "Effect": "Allow",
            "Action": [
                "cloudwatch:PutMetricAlarm",
                "cloudwatch:PutMetricData"
            ],
            "Resource": [
                "*"
            ]
        }
    ]
}
````

### Using IAM roles 
````
   'profil':'YOUR_PROFIL',
````

### Using creadential
Add your key and secret in the config file.
````
   'key':'YOUR_KEY',
   'secret':'YOUR_SECRET',
````


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
| Apache | Monitoring apache process number |

## License

This application licensed by Apache License Version 2.0.
