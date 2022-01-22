# Visualizar Usuário

Visualizar um usuário cadastrado.

**URL**: `/api/user/:id`

**Method**: `GET`

## Respostas de Sucesso

**Code**: `200 OK`

**Content**:

```json
{
  "id": 1,
  "name": "João Alves",
  "document": "44872223039",
  "email": "jalves@bestemail.com",
  "type": "common",
  "balance": "0.00",
  "created_at": {
    "date": "2022\/01\/22 16:28:55",
    "timezone": "America\/Sao_Paulo"
  },
  "updated_at": {
    "date": "2022\/01\/22 16:28:55",
    "timezone": "America\/Sao_Paulo"
  }
}
```

## Respostas de Erro

**Code**: `404 Not Found`

**Content**:

```json
{
  "type": "error",
  "message": "The user does not exist."
}
```