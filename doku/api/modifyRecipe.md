# Modify Recipe Endpoint

### endpoint

`/api/v1/recipe/modify`

**Action:** `put`
**Payload:**  `json`

### parameters

| parameter | type | comment |
|---|---|--|
| token | token | necessary |
| id | int | recipe id |
| title | plain text | optional |
| image | {"type":"jpg/png", "binary":"BIN"} | optional |
| ingredients | json | optional |
| duration | json | optional |
| steps | text/html | optional |



#### ingredients

*note*: if you change the ingredients, you need to resend all ingredients. 

##### parameters

| parameter | type |
| --------- | ---- |
| name      | text |
| amount    | text |
| unit      | text |

##### example

{"name":"Zucker", "amount":"150", "unit":"gr"}

#### duration

*note* if you change the durations, all durations have to be resent.

##### parameters

| parameter | type | unit |
| --------- | ---- | ---- |
| preparation      | int | min     |
| cooking    | int | min  |


##### example

{"preparation":60, "cooking":120}

### example

`{"token" : "xxx" ,"title":"Hackbraten","image":null,"ingredients":{"1":{"name":"Zucker","amount":"340","unit":"g"},"2":{"name":"Bier","amount":"2","unit":"l"}},"timings":{"prep":60,"cook":40},"steps":"text<\/html>"}`

### return

*400* invalid request
*200* OK - modified
*500* Internal Error

