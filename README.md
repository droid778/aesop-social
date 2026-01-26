# Getting Started

Social Media is a giant monolithic echo chamber, full of dangerous misinformation.  I think a better solution is a number of smaller invite-only echo chambers filled with subject matter experts.  The echo chambers can be federated as you like to join the chambers together.  At any point you can snip off a part of the network that becomes toxic.

Aesop Social is designed to scale to 1000 users.  It likes to live on a VPS with around 4GB RAM, 2 vCPUs, 100GB disk space.  Current pricing puts this at about a fish and chip dinner a month in running costs.  

1. SSH into your linux machine (skip if running locally).  Your host will have instructions for how to do this.  You'll either need root access (in which case remove sudo) or sudo installed.
2. sudo apt-get update
3. sudo apt install docker docker-compose libnss3-tools
4. Clone the repo
5. cd aesop-social
6. umask 077
7. Add a .env file containing the passwords.  This is excluded purposefully to prevent password reuse.  The easiest way is to copy / paste this into a text editor (one that doesn't have AI features, like sublime text).  Then edit the passwords (KeypassXC has a good keygen, click the dice).  Then in a terminal:

cat > .env

copy / paste the credentials:

MYSQL_ROOT_PASSWORD=strong-password-here
MYSQL_PASSWORD=strong-password-here 
FRIENDICA_ADMIN_EMAIL=email@address.com 

Ctrl-D to save / exit

You must use strong passwords for security and a real email address for federation to work.  Don't commit the .env file.


8. chmod 600
9. umask 022
10. docker-compose up -d

