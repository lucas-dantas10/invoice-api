# Documentação da Invoice API

## Descrição: Uma API RESTful para gerenciamento de faturas e consulta de usuários.

## Authentication Endpoints

### Efetuar login

- **Endpoint:** `/api/v1/login`
- **Method:** `POST`
- **Description:** Efetuar login de um usuário.
- **Request Body:**
    ```json
    {
        "email": "example.one@example.com",
        "password": "password"
    }
    ```
- **Response**
    - Status: `200 OK`
    - Content:
    ```json
    {
        "message": "Authorized",
        "status": 200,
        "data": {
            "token": "dklfjakjdajfkdj@*kdfalkdjfka" //exemplo de token
        }
    }
    ```

- **Response Error**
    - Status: `403 FORBIDDEN`
    - Content:
    ```json
    {
        "message": "Not Authorized",
        "status": 403,
        "data": []
    }
    ```

### Efetuar logout

- **Endpoint:** `/api/v1/logout`
- **Method:** `POST`
- **Description:** Efetuar o logout de um usuário.
- **Response**
    - Status: `200 OK`
    - Content:
    ```json
    {
        "message": "Token Revoked",
        "status": 200,
        "data": []
    }
    ```


## Usuário Endpoints

### Lista de todos usuários

- **Endpoint:** `/api/v1/users`
- **Method:** `GET`
- **Description:** Lista de todos os usuários.
- **Response**
    - Status: `200 OK`
    - Content:
    ```json
    {
        "data": [
            {
                "first_name": "Example",
                "last_name": "One",
                "full_name": "Example One",
                "email": "example.one@example.com"
            },
            {
                "first_name": "Example",
                "last_name": "Two",
                "full_name": "Example Two",
                "email": "example.two@example.com"
            },
            {
                "first_name": "Example",
                "last_name": "Three",
                "full_name": "Example Three",
                "email": "example.three@example.com"
            },
        ]
    }
    ```

### Pegar um usuário

- **Endpoint:** `/api/v1/users/{user_id}`
- **Method:** `GET`
- **Description:** Pegar um usuário específico.
- **Request Body**
    ```json
    user_id => integer
    ```
- **Response**
    - Status: `200 OK`
    - Content:
    ```json
    {
        "data": {
            "first_name": "Example",
            "last_name": "Two",
            "full_name": "Example Two",
            "email": "example.two@example.com"
        }
    }
    ```


## Invoice Endpoints

### Lista de todas as faturas

- **Endpoint:** `/api/v1/invoices`
- **Method:** `GET`
- **Description:** Retorna uma lista de todas as faturas.
- **Params:**
    - Content:
        ```json
            'gt'  // greater than
            'gte', // greter than equal
            'lt', // less than
            'lte', // less than equal
            'eq', // equal
            'ne', // not equal
            'in', // in
        ```
- **Example:**
    - Endpoint: `api/v1/invoices?paid[eq]=1` /** pagamento igual a 1 (todas as faturas pagas) **/
    - Content: /** Repare que todo 'paid' está como 'Pago'  **/
        ```json
            {
            "data": [
                {
                    "user": {
                        "firstName": "Kraig",
                        "lastName": "Predovic",
                        "fullName": "Kraig Predovic",
                        "email": "winston.little@example.com"
                    },
                    "type": "Boleto",
                    "value": "R$ 9,918.00",
                    "paid": "Pago",
                    "paymentDate": "30\/11\/2023 08:59:47",
                    "paymentSince": "há 2 semanas"
                },
                {
                    "user": {
                        "firstName": "Kraig",
                        "lastName": "Predovic",
                        "fullName": "Kraig Predovic",
                        "email": "winston.little@example.com"
                    },
                    "type": "Cartão",
                    "value": "R$ 3,128.00",
                    "paid": "Pago",
                    "paymentDate": "15\/11\/2023 23:22:48",
                    "paymentSince": "há 4 semanas"
                },
            ]
        }
        ```
- **Response:**
  - Status: `200 OK`
  - Content:
    ```json
        {
            "data": [
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
        }
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

- **Response:**
- Status: `200 OK`
- Content:
    ```json
        {
            "message": "Invoice created",
            "status": 200,
            "data": {
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
                }
            }
        }
    ```
- **Response Error:**
- Status: `400 BAD REQUEST`
- Content:
    ```json
        {
            "message": "Invoice not created",
            "status": 400,
            "data": []
        }

### Pegar uma fatura

- **Endpoint:** `/api/v1/invoices/{invoice_id}`
- **Method:** `GET`
- **Description:** Pegar uma fatura específica.
- **Params:**
  ```json
    invoice_id => integer
   ```
- **Response:**
- Status: `200 OK`
- Content:
    ```json
        {
            "data": {
                "user": {
                    "firstName": "Delta",
                    "lastName": "Heaney",
                    "fullName": "Delta Heaney",
                    "email": "mackenzie91@example.com"
                },
                "type": "Pix",
                "value": "R$ 12,000.00",
                "paid": "Não Pago",
                "paymentDate": null,
                "paymentSince": null
            }
        }
    ```


### Atuaizar uma fatura

- **Endpoint:** `/api/v1/invoices/{invoice_id}`
- **Method:** `PUT/PATCH`
- **Description:** Atuaizar uma fatura específica.
- **Request Body:**
  ```json
    {
        "user_id": 1,
        "type": "P", //P: pix, B: boleto, C: cartão
        "paid": 1, // 0 para 'não pago' e 1 para 'pago'
        "value": 9000.00
    }
   ```

- **Response:**
- Status: `200 OK`
- Content:
    ```json
        {
            "message": "Invoice updated",
            "status": 200,
            "data": {
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
                }
            }
        }
    ```
- **Response Error:**
- Status: `400 BAD REQUEST`
- Content:
    ```json
        {
            "message": "Invoice not updated",
            "status": 400,
            "data": []
        }
    ```

### Deletar uma fatura

- **Endpoint:** `/api/v1/invoices/{invoice_id}`
- **Method:** `DELETE`
- **Description:** Deletar uma fatura específica.
- **Params:**
  ```json
    invoice_id => integer
   ```
- **Response:**
- Status: `200 OK`
- Content:
    ```json
        {
            "message": "Invoice deleted",
            "status": 200,
            "data": []
        }
    ```
- **Response Error:**
- Status: `400 BAD REQUEST`
- Content:
    ```json
        {
            "message": "Invoice not deleted",
            "status": 400,
            "data": []
        }

