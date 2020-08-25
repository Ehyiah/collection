# collection

Symfony 5
EasyAdmin

Php7.4 

Extension PHP : mbstring, curl, mysql, json, xml

Mysql5.7

JWT token : lexik/jwt-authentication-bundle
- to generate private key : 
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096

- to generate public key:
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout

Need to change right files public and private key : chmod 755 -R config/jwt

If problem "Token not found", please, add the next sentance in conf apache vhost : SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
