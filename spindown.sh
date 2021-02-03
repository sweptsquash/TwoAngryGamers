#!/bin/bash
APPLICATION_NAME=twoangrygamers

helm del $APPLICATION_NAME
docker rm -f "${APPLICATION_NAME}_local_mount"