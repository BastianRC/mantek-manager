# Etapa de build
FROM node:18-alpine AS builder

# Aumentar el límite de memoria para Node.js durante el build
ENV NODE_OPTIONS="--max-old-space-size=2048"

WORKDIR /app
COPY . .

# 🔧 Generar .env antes del build
RUN echo "NUXT_PUBLIC_LARAVEL_API_URL=http://localhost:8000/api" > .env

RUN npm install
RUN npm run build

# Etapa de ejecución
FROM node:18-alpine

WORKDIR /app
COPY --from=builder /app ./

EXPOSE 3000
CMD ["node", ".output/server/index.mjs"]
