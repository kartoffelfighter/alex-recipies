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

`{'recipeName': 'Hackbraten','ingredients': [{'name: 'Zucker','amount':'450', 'unit':'g'},{ 'name':'Mehl', 'amount': '1', 'unit': 'kg' }],'steps': 'This is where your text is', 'timings': {'prep': 40,'oven': 80},'units':["g","kg","ml","l","pck","geh.  EL","gstr. EL","geh.  TL","gstr. TL","Tasse","Prise"]}),`

