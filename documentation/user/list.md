# Listar Usuários

Listar todos os usuários cadastrados.

**URL**: `/api/user`

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
      "name": "Felipy Amorim",
      "document": "03787890157",
      "email": "felipyamorim@gmail.com",
      "type": "common",
      "balance": "0.00",
      "created_at": {
        "date": "2022\/01\/22 15:42:11",
        "timezone": "America\/Sao_Paulo"
      },
      "updated_at": {
        "date": "2022\/01\/22 15:42:11",
        "timezone": "America\/Sao_Paulo"
      }
    },
    {
      "id": 2,
      "name": "Best Hardware",
      "document": "12807700000171",
      "email": "contact@besthardware.com",
      "type": "shopkeeper",
      "balance": "0.00",
      "created_at": {
        "date": "2022\/01\/22 16:18:05",
        "timezone": "America\/Sao_Paulo"
      },
      "updated_at": {
        "date": "2022\/01\/22 16:18:05",
        "timezone": "America\/Sao_Paulo"
      }
    }
  ]
}
```
