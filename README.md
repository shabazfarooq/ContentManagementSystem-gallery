TITLE
-----
    Content Management System

AUTHOR
------
    Shabaz Farooq
    www.ShabazFarooq.com

BUG REPORTS
-----------
    shabazfa@buffalo.edu

DESCRIPTION
-----------
- A custom administration panel was created to ease content management for the client. The entire panel was programmed in PHP and MySql, with an easy to use HTML front end.

- A unique login page designed to allow the administrator to login to the panel.

- Once an administrator successfully logged in, he or she could modify any and all textual
information displayed on the web site. Simple HTML text boxes and multi-line text boxes were used to display the content that was currently being displayed and also allowed for editing and saving. Upon editing, the content information stored in the Sql database was updated accordingly.

- An entire custom gallery page was created both in the administrator panel (where the administrator could edit and mange images) and on the web site (where people viewing the web site could view the images). Specific features were implemented for

- Custom gallery page where the administrator can upload new photos. Unique features implemented on the gallery page:

- Using a file form, the administrator can locate a file on the local computer for uploading

- Uploaded files can be added to a new category, or album. Or to a previous, existing album.

- Upon creation of a new category, a new folder would be created on the server. In addition, a new entry would be created under the ‘Category’ table in MySql, for file to database synchronization.

- Deletion of previously uploaded files, and category. Designed specifically in a way to ease the clients upload and deletion process.

- Upon uploading, the clients file would be processed as such: First, a small thumbnail would be generated. Then, the original image would be resized to 800x600. To keep bandwidth usage to a minimum.

- Unique contact form created, using HTML textfields coupled with PHP code that would take a potential customers inquiry and submit it to the administration panel, send the administrator and email, and also generate a text message (SMS) notifying the administrator.

