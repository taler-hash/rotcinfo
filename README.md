# CadetConnect: “A Streamlined ROTC Information System for Cebu Technological University – Consolacion Campus”

CadetConnect is an innovative information system designed specifically for the Reserve Officers' Training Corps (ROTC) program at Cebu Technological University's Consolacion Campus. This streamlined platform aims to enhance the management and organization of ROTC activities, student records, and training programs. CadetConnect provides a centralized hub for instructors, cadets, and administrators to access essential information, track progress, and streamline various administrative tasks related to the ROTC curriculum. By leveraging modern technology, CadetConnect seeks to improve efficiency, promote better communication, and foster a more effective learning environment within the ROTC program at CTU-Consolacion. This system represents a significant step forward in modernizing the ROTC operations, aligning them with contemporary educational standards and technological advancements.

## Tech Stacks
 - PHP
 - Nuxt ( Javascript Framework )
 - Tailwind ( CSS Framework )
 - Mysql
 - Apache ( WebServer )
## Pre requisites
Download the following packages
- Docker
- Git
- Node
## Deployment
To deploy this app you need to follow this steps:

1. Open Docker app
2. Create a folder in desktop name **rotcinfo**
3. Inside of that folder run a terminal
4. Clone the app using git
5. after cloning you should see **rotcinfo** folder open that folder. To build the app run this command inside of the folder youve just open just run this one time run ( run this after finishing the other one)
  - `docker compose build --no-cache app && docker compose up app -d && docker exec -it app bash -c "chmod 777 -R ./ && cp .env.example .env && composer install && php artisan config:clear && php artisan migrate:fresh --seed && npm install && npm run build && php artisan config:clear "`
  - `docker compose build --no-cache caddy && docker compose up caddy -d && docker exec -it app bash -c "chmod 777 -R ./"`
7. To start the app run this inside of the mentioned folder `docker compose up`
8. To stop the app run this inside of the mentioned folder `docker compose down`
9. After that you can access the application via `http://localhost`

### Developer
*Jurie Tylier Pedrogas ( Software Engineer )*

Development Time Range: 1month+

