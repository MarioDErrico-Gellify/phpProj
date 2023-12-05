COMPOSE_FILE = -f compose.yaml
run:
	bash localstack.sh
run-main:
	docker-compose -f compose.yaml up -d
restart-service:
	docker restart 843bece2c7a5
destroy:
	 docker container rm $(shell docker ps -aq) -f
	 "all container removed"
.PHONY: log
log:
	docker compose -p compose.yaml logs $(SERVICES) -f
create-app:
	npx create-react-app mia-app
