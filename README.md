# ShockLogic Test

Para llevar a cabo este proyecto se utilizó Laravel junto al paquete Laravel Livewire. Para poder ejecutarlo correctamente debes seguir las intrucciones de instalación.

### Video Demo
https://www.youtube.com/watch?v=zJjMzIqoAJM

## Instalación

### Pasos para instalar este proyecto en tu entorno local

- git clone https://github.com/gamg/shocklogictest.git
- composer install
- npm install
- npm run build
- Configurar base de datos en archivo .env
- php artisan migrate --seed

### Datos admin:
- User: admin@shocklogictest.com
- Password: password

### Datos usuario:
- User: tavo@shocklogictest.com
- Password: password

### Para ejecutar todos los Tests:

- php artisan test

### Para ejecutar un test específico, ejemplo:
- php artisan test --filter EventTest
