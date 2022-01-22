# Desafio

Desafio desenvolvido para o processo seletivo referente a vaga de **Desenvolvedor PHP - Sênior**.

## Ambiente

Para executar esse projeto você precisará do docker e docker-compose instalados.

    docker-compose up -d
    docker-compose exec api php bin/console doctrine:migrations:migrate

Após executar o comando, você poderá acessar a API através do seguinte endereço: http://localhost:8080

## API

### Endpoints Disponíveis

#### Usuário

* [Listar Usuários](user/list.md) : `GET /api/user`
* [Criar Usuário](user/create.md) : `POST /api/user`
* [Visualizar Usuário](user/show.md) : `GET /api/user/:id`

#### Transferência

* [Listar Transferência](user/list.md) : `GET /api/transfer`
* [Criar Transferência](transfer/create.md) : `POST /api/transfer`
* [Visualizar Transferência](transfer/show.md) : `POST /api/transfer`

## Testes

Para executar os testes é necessário executar os seguintes comandos.

    docker-compose exec api php bin/console --env=test doctrine:database:create
    docker-compose exec api php bin/console --env=test doctrine:schema:create

    # Unitário
    docker-compose exec api php vendor/bin/phpunit --filter Unit

    # Integração
    docker-compose exec api php vendor/bin/phpunit --filter Integration