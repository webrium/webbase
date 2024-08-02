## Captcha

Captcha can be re-created 5 times without limitation for each IP
After that, it will only be generated once every 60 seconds
As long as the captcha is entered correctly and confirmed


### Check whether it is allowed to create a new captcha or not

ًRoute : ``captcha/check-ability`` \
Type : post \
Output : {ok: true|false, message:''}

### Display the new captcha image
Route : ``captcha/show`` \
Type : get \
Output : Image

## Admin

### Auth admin
After authentication, we must send the auth_token value in each request through the header

Route : ``admin/auth`` \
Type : post \
Params : `username`, `password`, `captcha` \
Output : {ok: true|false, auth_token: '...'}
