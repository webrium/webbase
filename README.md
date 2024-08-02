## Captcha

Captcha can be re-created 5 times without limitation for each IP
After that, it will only be generated once every 60 seconds
As long as the captcha is entered correctly and confirmed


### # Check whether it is allowed to create a new captcha or not

ًRoute : ``captcha/check-ability`` \
Type : post \
Output : {ok: true|false, message:''}

### # Display the new captcha image
Route : ``captcha/show`` \
Type : get \
Output : Image

## Admin

### # Auth admin
After authentication, we must send the auth_token value in each request through the header

Route : ``admin/auth`` \
Type : post \
Params : `username`, `password`, `captcha` \
Output : {ok: true|false, auth_token: '...'}


### Create new admin

Route : ``admin/new``
Type : post \
Params : `name`, `username`, `password`, `confirm_password`, `role`


### update admin
If admin_id is not sent, the current user will be edited, and if it is sent, if the current user's role is admin, he has the ability to edit other administrators.

And any parameters sent are edited and all fields are optional

Route : ``admin/new``\
Type : post \
Params : `name`, `username`, `password`, `admin_id`

