# Visualizar Transferência

Visualizar uma transferência cadastrada.

**URL**: `/api/transfer/:id`

**Method**: `GET`

## Respostas de Sucesso

**Code**: `200 OK`

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
    "balance": "900.00",
    "created_at": {
      "date": "2022\/01\/22 16:28:55",
      "timezone": "America\/Sao_Paulo"
    },
    "updated_at": {
      "date": "2022\/01\/22 17:14:26",
      "timezone": "America\/Sao_Paulo"
    }
  }
}
```

## Respostas de Erro

**Code**: `404 Not Found`

**Content**:

```json
{
  "type": "error",
  "message": "The transfer does not exist."
}
```