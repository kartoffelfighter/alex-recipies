# Create Account Endpoint

### endpoint

`/api/v1/account/create`

**Action:** `post`
**Payload:**  `json`

### parameters

| parameter | type | max |
|---|---|--|
| token |  |  |
| firstname | plain text | 15 |
| lastname  | plain text | 15 |
| email     | email | 40 |
| password  | md5 | 60 |



### example

`{"token": "xxxx","firstname":"Maxi", "lastname":"Mustermann", "email": "maxi@mustermanns.de", "password":"cc03e747a6afbbcbf8be7668acfebee5"}`



### return

*400* invalid request
*201* OK - created
*500* Internal Error

