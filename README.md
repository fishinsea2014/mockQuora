# mockQuora
This project is to mock a basic Quora.

#Back end API document v1.0.0
##General API reference rules:
- All API is start by 'domain.com/api/'
- An API has two part, like 'domain.com/api/part_1/part2'
  - 'part_1'is the name of the model, such as 'user' or 'question'
  - 'part_2' is the name of a behavior, such as 'login'
- CRUD
  - Every model will has CRUD methods, which are: add, remove, change, read
#Model
##Question (only take question, change as examples)

- Authority: login required.
- Parameters:
  - Mandatory fields: title,
  - Optional fields: desc (description)
   
### 'change'
- Authority: login as the owner of the question required.
- Parameters:
  - Mondatory: id (id of a question)
  - Optional fields: 'title', 'desc'(description) 
   
     
 
