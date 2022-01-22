# Criar Transferência

Criar uma nova transferência.

**URL**: `/api/user`

**Method**: `POST`

**Data**:

```json
{
  "payer": 1,
  "payee": 2,
  "value": 100
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
    "payer": 1,
    "payee": 2,
    "value": "100",
    "status": "pending",
    "created_at": {
      "date": "2022\/01\/22 17:14:26",
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

**Code**: `422 Unprocessable Entity`

**Content**:

```json
{
  "type": "error",
  "errors": {
    "payer": "The user does not exist.",
    "payee": "The user does not exist.",
    "value": "This value should be greater than 0."
  }
}
```

```json
{
  "type": "error",
  "errors": [
    "Shopkeeper can't perform a transfer values for others users."
  ]
}
```

```json
{
  "type": "error",
  "errors": [
    "Insufficient balance to make the transfer."
  ]
}
```

```json
{
  "type": "error",
  "errors": [
    "It's not possible to perform a transfer to the same source user."
  ]
}
```