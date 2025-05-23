# Use official Node.js image to build Angular app
FROM node:18-alpine as build

WORKDIR /app
COPY login-app/ .

COPY package*.json ./
RUN npm install

RUN npm run build

# Use nginx to serve the Angular app
FROM nginx:alpine
COPY --from=build /app/dist/frontend /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
