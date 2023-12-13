#!/bin/bash
#variables string
var_do_you_restart='Do you want to restart localstack? [Y/n]:'
var_your_command="your command is"
var_local_stack_already_up="Localstack is already running"
var_do_you_shutting_down_localstack="Do you want to turn off localstack? [y/n]:"
var_compose_yaml_not_exist="the compose.yaml file does not exist"
var_nothing_fount="no containers found"
# shellcheck disable=SC2034
var_name_of_app="my-app"

destroy_localstack(){
      # shellcheck disable=SC2046
      docker stop $(docker ps -q)
      docker-compose rm -v
      docker system prune
      # shellcheck disable=SC2162
      read -p "$var_do_you_restart" update
      echo "$var_your_command: $update"
}

compose_localstack(){
   docker compose up -d
   docker-compose exec my-apache-php php -m | grep pdo_pgsql
   docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' my-mysql
}

if [ -f compose.yaml ]
then
    active_containers=$(docker ps -q)
    if [ -n "$active_containers" ]
    then
        echo "$var_local_stack_already_up"
            # shellcheck disable=SC2162
            read -p "$var_do_you_shutting_down_localstack" decision
            echo "$var_your_command $decision"
            if [ "$decision" == "y" ]; then
                destroy_localstack
              if [ "$update" == 'y' ]; then
                 compose_localstack
              fi
            fi
    else
        echo "$var_nothing_fount"
        compose_localstack
    fi
else
    echo "$var_compose_yaml_not_exist"
fi

