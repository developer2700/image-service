# ImageService php8.2.7
### Prerequisites

 - [docker](https://www.docker.com/)
 - docker-compose

## Setup

* In project directory:
  ```
  docker-compose build
  docker-compose up
  ```
* Access the project by :
  ```
  http://localhost:8080/
  ```
* Example URLs to test:
  * http://localhost:8080/dog.jpg/crop-200-200
  * http://localhost:8080/dog.jpg/crop-400-400
  * http://localhost:8080/dog.jpg/resize-300-300
  * http://localhost:8080/dog.jpg/resize-100-100
   
