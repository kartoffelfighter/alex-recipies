# Login Account Endpoint

### endpoint

`/api/v1/account/login`

**Action:** `get`
**Payload:**  `json`

### parameters

| parameter | type | max |
|---|---|--|
| email     | email | 40 |
| password  | md5 | 60 |



### example

`{"email": "maxi@mustermanns.de", "password":"cc03e747a6afbbcbf8be7668acfebee5"}`



### return

*400* invalid request
*200* OK
*500* Internal Error

note: on *200* OK the server will also return a json-string including your user-id, your login-token and the lifetime of this token