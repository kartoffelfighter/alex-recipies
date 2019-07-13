# list Recipe Endpoint

### endpoint

`/api/v1/recipe/list`

**Action:** `get`
**Payload:**  `json`

### parameters

| parameter | type  | comment                       |
| --------- | ----- | ----------------------------- |
| token     | token |                               |
| amount    | int   | amount of recipes to be shown |
|           |       |                               |
|           |       |                               |
|           |       |                               |
|           |       |                               |



### return

*400* invalid request
*201* OK  + payload
*500* Internal Error

### payload

`{'recipies':[{'title':'Hackbraten', 'id': 1}, {'title':'Käsebrot', 'id': 2}, ... ]}`

