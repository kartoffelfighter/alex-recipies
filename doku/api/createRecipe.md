# Create Recipe Endpoint

### endpoint

`/api/v1/recipe/create`

**Action:** `post`
**Payload:**  `json`

### parameters

| parameter | type | max |
|---|---|--|
| token | token |  |
| title | plain text | 25 |
| image | {"type":"jpg/png", "binary":"BIN"} |  |
| ingredients | json |  |
| duration | json |  |
| steps | text/html | |



#### ingredients

##### parameters

| parameter | type |
| --------- | ---- |
| name      | text |
| amount    | text |
| unit      | text |

##### example

{"name":"Zucker", "amount":"150", "unit":"gr"}

#### duration

##### parameters

| parameter | type | unit |
| --------- | ---- | ---- |
| preparation      | int | min     |
| cooking    | int | min  |


##### example

{"preparation":60, "cooking":120}

### example



### return

*400* invalid request
*201* OK - created
*500* Internal Error

