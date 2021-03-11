[![Build Status](https://travis-ci.org/fauguste/cloudwatch-script-php.svg)](https://travis-ci.org/fauguste/cloudwatch-script-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fauguste/cloudwatch-script-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fauguste/cloudwatch-script-php/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/482807e9-f93b-48f0-8dd5-51d3cc1b673f/mini.png)](https://insight.sensiolabs.com/projects/482807e9-f93b-48f0-8dd5-51d3cc1b673f)
[![Code Climate](https://codeclimate.com/github/fauguste/cloudwatch-script-php/badges/gpa.svg)](https://codeclimate.com/github/fauguste/cloudwatch-script-php)
[![Test Coverage](https://codeclimate.com/github/fauguste/cloudwatch-script-php/badges/coverage.svg)](https://codeclimate.com/github/fauguste/cloudwatch-script-php)

# Amazon CloudWatch Monitoring Scripts for EC2 Instance

This project provide some scripts in order to monitor your EC2 instances with CloudWatch.  
You can add your own scripts in the plugin directory.

## Requirements

This libraries are required for this project :  
```
# Using PHP5
php5-cli, php5-curl

# Using PHP7
php-cli, php-curl
```

## Configuration

Authorize this policy :
````
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Sid": "Stmt1446055544000",
            "Effect": "Allow",
            "Action": [
                "cloudwatch:PutMetricAlarm",
                "cloudwatch:PutMetricData",
                "cloudwatch:DeleteAlarms"
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

### Using credentials
Add your key and secret in the config file.
````
   'key':'YOUR_KEY',
   'secret':'YOUR_SECRET',
````


## Usage

Send metrics to CloudWatch (Run every 5 minutes)`

```
php metrics.php [-f config-file]
```

Create alarms in CloudWatch (Run one time)
```
php alarmes.php [-f config-file]
```

Delete alarms in CloudWatch (Run one time)
```
php delete-alarmes.php [-f config-file]
```

## Plugins

| Name | Description          |
| ------------- | ----------- |
| Solr      | Monitoring ping solr URL |
| Apache | Monitoring apache process number |
| Disk | Monitoring disk usage |
| Inodes | Monitoring disk inodes usage |
| Sftp | Monitoring SFTP access |
| Memory | Monitoring memory percentage of used |
| Http | Monitoring HTTP URL with pattern |
| Elastics | Monitoring Elasticsearch |
| SolrCdcr | Monitoring CDCR |


## License

This application licensed by Apache License Version 2.0.
