#!/usr/bin/env bash

CONTAINER_NAME=backend-docker-container
# path to compiled front end files
FRONTEND_COMPILED_FILES=./../../frontend/dist

docker stop ${CONTAINER_NAME}
docker rm ${CONTAINER_NAME}

docker run =p 80:3000 \
--name ${CONTAINER_NAME} \
-v ${FRONTEND_COMPILED_FILES}:/dist/ \
-v `pwd`:/app \
boxname \
/app/scripts/dev_entrypoint.sh