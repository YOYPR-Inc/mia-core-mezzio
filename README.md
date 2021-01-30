# mia-core-mezzio

# Como Instalar Swagger UI
1. Copiar carpeta public/swagger en el proyecto Mezzio.
2. Cambiar URL de la API en index.html
3. Agregar handler en app.yaml
```yaml
# Serve a directory as a static resource.
- url: /swagger
  static_dir: public/swagger
```
4. Generar archivo swagger.json
```bash
./vendor/bin/openapi --format json --output public/swagger.json src config vendor/agencycoda
```