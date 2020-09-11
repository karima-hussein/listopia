# Listopia # #task
listopia is a very simple app where user can make lists of his favourite books, view and download books in pdf format.

user can aslo import books from a general list-I just made one for example sake-
# Data
I used [JSONbin.IO](https://jsonbin.io) to store a json file containing the data

I uploaded a file OnlineData.js containing a copy

Json Structure
```
[
  {
    "userId": "1",
    "userName": "karima hussein",
    "lists": [
      {
        "listName": "karima's list",
        "books": [
          {
            "book name": "book1",
            "author": "author name 1",
            "release date": "2020",
            "cover image": "image"
          }
        ]
      },
      {
        "listName": "read2020",
        "books": []
      }
    ]
  },
  
  {
    "userId": "2",
    "userName": "john doe",
    "lists": [
    ]
  }
  
]
```

# Fetching Data
I use cURL to fetch data using the api provided by [JSONbin.IO](https://jsonbin.io)
# Books
I uploaded a few examples so that the download link will work correctly
