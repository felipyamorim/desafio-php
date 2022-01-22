# Criar Usuários

Criar um novo usuário.

**URL**: `/api/user`

**Method**: `POST`

**Data**:

```json
{
  "name": "João Alves",
  "email": "jalves@bestemail.com",
  "document": "448.722.230-39"
}
```

## Respostas de Sucesso

**Code**: `201 Created`

**Content**:

```json
{
  "type": "success",
  "data": {
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
}
```

## Respostas de Erro

**Code**: `422 Unprocessable Entity`

**Content**:

```json
{
  "type": "error",
  "errors": {
    "name": "This value should not be blank."
  }
}
```