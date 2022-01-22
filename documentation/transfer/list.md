# Listar Transferências

Listar todas as transferências cadastradas.

**URL**: `/api/transfer`

**Method**: `GET`

## Respostas de Sucesso

**Code**: `200 OK`

**Content**: 

```json
{
  "type": "success",
  "data": [
    {
      "id": 1,
      "payer": 1,
      "payee": 2,
      "value": "100.00",
      "status": "approved",
      "created_at": {
        "date": "2022\/01\/22 17:14:26",
        "timezone": "America\/Sao_Paulo"
      },
      "updated_at": {
        "date": "2022\/01\/22 17:14:30",
        "timezone": "America\/Sao_Paulo"
      }
    },
    {
      "id": 2,
      "payer": 1,
      "payee": 5,
      "value": "50.00",
      "status": "approved",
      "created_at": {
        "date": "2022\/01\/22 17:20:40",
        "timezone": "America\/Sao_Paulo"
      },
      "updated_at": {
        "date": "2022\/01\/22 17:20:42",
        "timezone": "America\/Sao_Paulo"
      }
    }
  ]
}
```
