# Show Recipe Endpoint

### endpoint

`/api/v1/recipe/show`

**Action:** `get`
**Payload:**  `json`

### parameters

| parameter | type | comment |
|---|---|--|
| token | token |  |
| id        | int   | recipe id |
|           |       |           |
|           |       |           |
|           |       |           |
|           |       | |



### return

*400* invalid request
*201* OK  + payload
*500* Internal Error

### payload

`{"title":"Hackbraten","image":null,"ingredients":{"1":{"name":"Zucker","amount":"340","unit":"g"},"2":{"name":"Bier","amount":"2","unit":"l"}},"timings":{"prep":60,"cook":40},"steps":"text<\/html>"}`

