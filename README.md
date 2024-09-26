# Project setup instruction

- clone the repository 
- ### cd testing_system_task/docker

- ### docker compose up -d 
- (make sure that ports 8080 and 5432 are free)

- ### docker exec -it test_php_app bash

- ### docker exec -it test_php_app bash

- ### php bin/console doctrine:migrations:migrate

- ### php bin/console load_questions

- http://localhost:8080/test