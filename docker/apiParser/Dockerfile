FROM node:14.19.0

# RUN apk add --update --no-cache udev ttf-freefont chromium
RUN apt update  && apt upgrade -y  && apt install chromium -y 

WORKDIR /app
# COPY ./api_parser/ /app
# RUN npm install

ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD="true" \
    PUPPETEER_EXECUTABLE_PATH="/usr/bin/chromium"

CMD ["npm", "run", "start:dev"]