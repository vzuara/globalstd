FROM node:18-alpine
ENV HOST=0.0.0.0

WORKDIR /var/www/frontend
COPY package*.json .
RUN npm install
COPY . .
EXPOSE 8080
CMD [ "npm", "run", "serve" ]