# /login-app/Dockerfile
# Stage 1: Build the Angular app
FROM node:18 as build

WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

# Stage 2: Serve with Nginx
FROM nginx:alpine

COPY --from=build /app/dist/login-app /usr/share/nginx/html

# Optional: Replace default Nginx config (if needed)
# COPY nginx.conf /etc/nginx/conf.d/default.conf


EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
