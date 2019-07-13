# Create Account Endpoint

### endpoint

`/api/v1/account/modify`

**Action:** `put`
**Payload:**  `json`

### parameters

| parameter | type | optional | max |
|---|---|--|--|
| token | token |  |  |
| firstname | plain text | * | 15 |
| lastname  | plain text | * | 15 |
| email     | email | * | 40 |
| password  | md5 | * | 60 |

*note*: values marked with a star are optional. if no new content is sent, the api will force the value as unchanged.

### example

`{"token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c", "firstname": "Harald"}`



### return

*400* invalid request
*201* OK - created
*500* Internal Error

