# Romanian Election Simulation System

## Overview
A Domain-Driven Design (DDD) application simulating the Romanian election process, built using PHP 8.4.

## Project Structure
- `src/Domain/`: Core domain logic
- `src/Infrastructure/`: External integrations
- `src/Application/`: Application services and DTOs

## Requirements
- PHP 8.4
- Composer
- RabbitMQ
- Doctrine ORM

## Setup
1. Clone the repository
2. Run `composer install`

## Validation Rules
1. Voting hours: 7:00 AM - 9:00 PM
2. One vote per voter
3. Valid voter ID required
4. Candidate must be BEC approved

## Design Principles
- Domain-Driven Design
- SOLID Principles
- Clean Code Practices
