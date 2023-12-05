# Prerequisites 

Download and install docker desktop to : https://www.docker.com/get-started/

# **Docker compose guideline**

this project creates a localstack with 2 different docker containers
1) my-apache with the php module and pdo class.
2) postgresql 

#create localstack.
To create localstack: launch the command in the root, via a git bash console:
```shell
./localstack.sh
 ```

or run the make run command
   ```shell
     make run
   ```

# **Add migration to db with prisma**

run in order :
go to C:\getting-started-app-v2\backend\prisma_client
and :
 ```shell
    npm prisma generate 
    
    npx prisma migrate dev --name init 
   ```
Now app is available to http://localhost:8081/ address