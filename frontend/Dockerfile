# Etapa de build
FROM node:18-alpine AS builder

WORKDIR /app
COPY . .

# 🔧 Generar .env antes del build
RUN echo "LARAVEL_API_URL=http://localhost:8000/api" > .env

RUN npm install
RUN npm run build

# Etapa de ejecución
FROM node:18-alpine

WORKDIR /app
COPY --from=builder /app ./

EXPOSE 3000
CMD ["node", ".output/server/index.mjs"]
