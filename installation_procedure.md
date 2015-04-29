#LsToXero Installation Procedure:

## 1. Copy the files to xp.launchstars.sg in var/www/ltxvi/public directory


## 2. UPDATE THE DATABASE
  
  **tblpartner**
  
  * add 		partner_country 	varchar(45)
  * Add 		api_endpoint 		varchar(256)
  * add		isDefault			tinyint(4)
  * remove 	api_token

  **tblaccounts**
  
  * add 		pos_payment_type_id	pos_payment_type_id(256)

  **tblmerchant**
  
  * Add partner_sn				smallint()

  **tbluser**
  
  * remove	tblTokenId

  seed data in tblpartner


## 3. UPDATE THE CRON
  use crontab -e to update and add the line bellow in cron
  `php /var/www/html/ls2xero.vi/public_html/cron.php cron/dailyCron`

## 4. Update the virtualhost ls2xero.conf and restart the apache server

## 5. Login to system and update the LinkedAccounts.