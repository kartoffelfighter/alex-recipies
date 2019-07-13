# Search Recipe Endpoint

### endpoint

`/api/v1/recipe/search`

**Action:** `get`
**Payload:**  `json`

### parameters

| parameter | type |
|---|---|
| token | token |
| search  | string |
|           |       |
|           |       |
|           |       |
|           |       |



### return

*400* invalid request
*201* OK  + payload
*500* Internal Error

### payload

`{'recipies':[{'title':'Hackbraten', 'id': 1}, {'title':'Käsebrot', 'id': 2}, ... ]}`