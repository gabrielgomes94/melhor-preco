docker-compose build
docker-compose up -d

docker exec -it barrigudinha-db psql -U barrigudinha_user -c "DROP DATABASE IF EXISTS barrigudinha_dev";
docker exec -it barrigudinha-db psql -U barrigudinha_user -c "DROP DATABASE IF EXISTS barrigudinha_test";

docker exec -it barrigudinha-db psql -U barrigudinha_user -c "CREATE DATABASE barrigudinha_dev";
docker exec -it barrigudinha-db psql -U barrigudinha_user -c "GRANT ALL PRIVILEGES ON DATABASE barrigudinha_dev TO barrigudinha_user";

docker exec -it barrigudinha-db psql -U barrigudinha_user -c "CREATE DATABASE barrigudinha_test";
docker exec -it barrigudinha-db psql -U barrigudinha_user -c "GRANT ALL PRIVILEGES ON DATABASE barrigudinha_test TO barrigudinha_user";
