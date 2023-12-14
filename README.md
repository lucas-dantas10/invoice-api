# Documentação da Invoice API

## Descrição: Uma API RESTful para gerenciamento de faturas e consulta de usuários.


## Invoice Endpoints

### Lista de todas as faturas

- **Endpoint:** `/api/v1/invoices`
- **Method:** `GET`
- **Description:** Retrieves a list of all invoices.
- **Response:**
  - Status: `200 OK`
  - Content:
    ```json
     [
		{
			"user": {
				"firstName": "Example",
				"lastName": "One",
				"fullName": "Example One",
				"email": "example.one@example.com"
			},
			"type": "Pix",
			"value": "R$ 12,000.00",
			"paid": "Não Pago",
			"paymentDate": null,
			"paymentSince": null
		},
		{
			"user": {
				"firstName": "Example",
				"lastName": "Two",
				"fullName": "Example Two",
				"email": "example.two@example.com"
			},
			"type": "Boleto",
			"value": "R$ 9,918.00",
			"paid": "Pago",
			"paymentDate": "30/11/2023 08:59:47",
			"paymentSince": "há 2 semanas"
		},
		{
			"user": {
				"firstName": "Example",
				"lastName": "Three",
				"fullName": "Example Three",
				"email": "example.three@example.com"
			},
			"type": "Cartão",
			"value": "R$ 9,918.00",
			"paid": "Pago",
			"paymentDate": "30/11/2023 08:59:47",
			"paymentSince": "há 2 semanas"
		},
	]
    ```

### Criar uma nova fatura

- **Endpoint:** `/api/v1/invoices`
- **Method:** `POST`
- **Description:** Cria uma nova fatura.
- **Request Body:**
  ```json
    {
        "user_id": 1,
        "type": "P", //P: pix, B: boleto, C: cartão
        "paid": 1, // 0 para 'não pago' e 1 para 'pago'
        "value": 9000.00
    }
   ```
