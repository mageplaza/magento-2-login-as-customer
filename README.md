
# Magento 2 Login As Customer 

[Login as Customer by Mageplaza](https://www.mageplaza.com/magento-2-login-as-customer/) supports the store admin to login to customers' account and automatically save that login data. In many cases, customers face some difficulty or inconvenience in My Account page, or right in the checkout step. Login as Customer module will be a great solution for such these circumstances. The store can have a quick view after access as a customer, as a result, this can save a significant amount of time for both administrator and customers.



## 1. Documentation

- Installation guide: https://www.mageplaza.com/install-magento-2-extension/
- User guide: https://docs.mageplaza.com/login-as-customer/index.html
- Introduction page: http://www.mageplaza.com/magento-2-login-as-customer/
- Contribute on Github: https://github.com/mageplaza/magento-2-login-as-customer
- Get Support: https://github.com/mageplaza/magento-2-login-as-customer/issues


## 2. FAQs

**Q: I got error: Mageplaza_Core has been already defined**

A: Read solution: https://github.com/mageplaza/module-core/issues/3

**Q: I am a store administrator, how can I access a customer’s account?**

A: You can quickly login customer’s account to get information from Order View and Customer View right on the admin backend. 

**Q: I am a store owner, my store site has many admin accounts. How can I manage customers' login history?**

A: The extension allows store owners to view access history. On the backend, please navigate Report > Customer > Login as Customer Logs. 

**Q: Is it possible to export logs data to save daily?**

A:  Yes, it is totally possible. From the report logs, you can hit the Export button and select the exported CSV or XML file. 


## 3. How to install Login as Customer extension for Magento 2
- Install via composer (recommend)
- Run the following command in Magento 2 root folder:

```
composer require mageplaza/module-login-as-customer
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

## 4. Highlight features


### Instantly access to any customer account 

One of the most noticeable features of Login as Customer extension is that the store admin can log in a customer’s account to take some necessary actions.

![Imgur](https://i.imgur.com/wjxAovr.png)

#### Easy access from convenient places 

On the Magento 2 backend, the admin can quickly access the account of any customer by selecting between Order View and Customer View options. Right here, there are two important places, in which all information of customers and orders is continuously updated. Hence, Login as Customer link is placed here, to support admins in accessing quickly and conveniently, without any difficulty. 

#### Only one click to access all information needed

On the pages mentioned, with only one click on the Login as Customer button, the admin will be redirected instantly to customers’ account with full actual information such as my dashboard, order information, account information, etc. With this module, it is not only easy to access but is also possible to edit or make any updates in the blink of an eye.



### Record login history

![Imgur](https://i.imgur.com/Uvg5qTA.png)

#### Continually record every login attempt

Any access to customers' account can be recorded exactly in Login as Customer Logs section on the backend. There is a report here, which provides all access information, including date and time, customer account, admin account.
 
#### Manage and track customer/order information easily 

In case a store has multiple admin accounts, the access report mentioned above is potential for the store owner. It effectively supports managing and tracking every single admins' login as customer attempt. Furthermore, deleting or editing any data is not allowed on this report. As a result, it is definite that the admin will always be updated about any changes related to customers, and is able to avoid unexpected ill-intentioned access as well. 



### Export login logs function

Login as Customer module by Mageplaza also support the export function. On the report log, the administrator can easily export login data so that they can save those data on the daily or monthly basis with ease. By this way, it is easy to store the login records, then use for login information management or any other specific purposes. 

The most common-used exported file formats are CSV and Excel XML.  

![Imgur](https://i.imgur.com/nlgTMbm.png)


## 5. Full Feature List

### For admins
- Enable/disable the extension 
- Login as customer from Order View 
- Login as customer from Customer View
- Easily view and track recorded login access 
- Possible to export login data to CSV or Excel XML 

### For customers
- Quickly get support from the store’s admins in editing order information or customer information  
- Save time and effort to edit information, accordingly, have a better shopping experience



## 6. How to configure Login as customer

### 6.1.Configuration

From **Admin panel**, go to `Stores > Configuration > Mageplaza > Login as Customer` 

![Imgur](https://i.imgur.com/s7jE6Zr.png)

- Select **Enable = Yes**:
  - Activate the module. Then, admin can log in customer’s account from the admin backend. 
  - `Login as Customer` button will be displayed on Customer View and Order View sections from admin backend.
  
- **Customer Edit**
  
![Imgur](https://i.imgur.com/YQni7Dz.png)

- **Order View**

![Imgur](https://i.imgur.com/pdS3kop.png)



### 6.2. Login as Customer Logs

From **Admin panel**, select `Report > Customer > Login as Customer Logs`

- Any access from any admin account will be recorded
- Not allowed to delete or edit any information on this log history
- Admin can export any log to CSV or XML files

![Imgur](https://i.imgur.com/CoeCxzo.png)
