# Session 6 – URL Shortener Module

## Purpose of the module

This module allows users to create short URLs from long URLs and redirect users from a short code to the original URL.

## Functional requirements

The system accepts a long URL and returns a short URL.  
The system redirects users from a short code to the original URL.  
The system validates the original URL.  
The system stores URL mappings in PostgreSQL.  
The system counts redirects using click_count.

## Non-functional requirements

The redirect should be fast.  
The short code should be unique.  
The API should return consistent JSON responses.  
The system should use correct HTTP status codes.  
The list endpoint should use Redis cache.

## Base62 encoding

Base62 converts numeric IDs into short text codes using digits, lowercase letters, and uppercase letters. This is useful because database IDs can be represented as short readable strings.

## Endpoints

POST /api/78709/v1/short-links  
GET /api/78709/v1/short-links  
GET /api/78709/v1/short-links/{id}  
GET /r/{code}

## Testing evidence

The implementation was tested with screenshots showing a successful POST request, successful GET list request, 422 validation error, 302 redirect response, 404 missing short code response, and Redis DBSIZE after cache usage.