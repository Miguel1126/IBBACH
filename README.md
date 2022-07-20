<p align="center"><img src="https://raw.githubusercontent.com/Miguel1126/IBBACH/main/resources/js/vue/assets/logo.jpg" width="300"></p>

# IBBACH

## Installation

After dowloading, run the command below, it will directly install the dependencies for composer and NPM and will also create the `.env ` file and generates de app key.   

```bash
  npm run setup
```

### Run the migrations

```bash
  php artisan migrate
```

### Run the database seeder

The seeder will store some base data to the database

```bash
   php artisan db:seed 
```

### Compile js and css files

```bash
  npm run dev || npm run watch
```

### Run the server and everything should be working

```bash
  php artisan serve
```

## License
Authors: Miguel Ardón, Kevin Chacón, Fredy Alvarez, Cesar Escobar. 2022.
[Laravel MIT license](https://opensource.org/licenses/MIT).
