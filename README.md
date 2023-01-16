# Creating a Restful API with PHP (no frameworks)
 
Creation of a RESTful API with PHP without using frameworks (With the help of the playlist https://youtube.com/playlist?list=PLIbWwxXce3VpvBT_O977da8XECEp-JTJt made by [Wilfredo Aleman](https://github.com/waleman)]
 
### Previous requirements
This project was run using the XAMPP control panel with the following features: Apache 2.4.46, MariaDB 10.4.1, and PHP 7.4.10
 
### Introduction
* Goal: The objective of this project is to understand the REST communication standard as well as the internal functioning of a RESTful API without having to use PHP frameworks and thus deepen the understanding of this important topic in web development.

* Theoretical framework:
Some important concepts in this topic are the following:

    REST is the standard for communication between computers over the Internet, it is the most common.

    API stands for Application Programming Interface, it is a way for two computers to communicate with each other.

    The common API standard used by most mobile and web applications to communicate with servers is called REST. It stands for Representational State Transfer. REST is a new set of rules that has been the common standard for building web APIs since the early 2000s.
    Likewise, an API that follows the REST standard is called a RESTful API. Some real life examples are Twilio, Stripe, and Google Maps.

    What happens with an API is the following: A client interacts with a resource by making a request to the resource's endpoint over HTTP. The request has a very specific format, as shown in the following image. The request contains the URI of the resource that we would like to access. The URI is preceded by an HTTP verb (POST in the image) that tells the server what we want to do with the resource. A POST request means that we want to create a new resource. A GET means that we want to read the data about an existing resource. A PUT is used to update an existing resource. A DELETE is to remove an existing resource. In the body of these requests, there could be an optional HTTP request body that contains a custom payload of data, typically JSON-encoded.
    This is illustrated in figure 1.

    ![Figure 1](https://github.com/Samvel24/API-Restful-PHP/blob/master/ImagenesTeoria/Figura1.png)  
    **Figure 1. Client that sends a POST request to a server, the body of the request contains the customer, quantity and price data in JSON format.**

    A well-implemented RESTful API returns proper HTTP status codes. Level 200 codes mean the request was successful. Level 400 codes mean there was a problem with our request. For example, the requests contain incorrect syntax. At level 500, it means something went wrong at the server level. For example, the service was not available. An example of this can be seen in Figure 2.

    ![Figure 2](https://github.com/Samvel24/API-Restful-PHP/blob/master/ImagenesTeoria/Figura2.png)  
    **Figure 2. Server returning a 200 status code as a response, this means that the request was made successfully.**

    A well-behaved client could choose to retry a failed request with a status code of level 500. The meaning of "could choose to retry" means that some actions are not idempotent (idempotency is the property to perform a a given action multiple times and still achieve the same result as if it were performed only once) and require special care when retrying. When an API is idempotent, making multiple identical requests has the same effect as making a single request. This is typically not the case for a POST request to create a new resource. See figure 3 and 4.

    ![Figure 3](https://github.com/Samvel24/API-Restful-PHP/blob/master/ImagenesTeoria/Figura3.png)  
    **Figure 3. Client considering redoing the request but taking the respective care to do it correctly through the proper sending of data, for example, placing the missing data in JSON format.**

    ![Figure 4](https://github.com/Samvel24/API-Restful-PHP/blob/master/ImagenesTeoria/Figura4.png)  
    **Figure 4. Idempotency property for each HTTP request.**

### References
* [1] https://blog.bytebytego.com/p/why-is-restful-api-so-popular, accessed January 2023.
* [2] https://www.youtube.com/watch?v=-mN3VyJuCjM, accessed January 2023.

***

2023 [Samuel Ramirez](https://github.com/Samvel24/)