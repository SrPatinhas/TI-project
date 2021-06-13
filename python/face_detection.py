#!/usr/bin/env python
# Python program to save image from webcam and save only the face
# importing cv2
import cv2
# module for posting files
import requests

from msvcrt import (kbhit, getch)

# image from camera
camera = cv2.VideoCapture(0)

def send_file():
    url = 'http://ti.test/api/v1/security'
    files = {'media': open('security.png', 'rb')}
    requests.post(url, files=files)

def take_picture():
    ret, image = camera.read()
    print ("Foto tirada")
    # Guarda imagem
    cv2.imwrite('security.png', image)
    #envia image para API
    send_file()
while True:
    try:
        if kbhit():
            tecla = getch() #evento que deteta tecla pressionada
            #Tira foto e envia com E ou S pressionado
            if tecla == b'e' or tecla == b's':
                take_picture()
            #Termina com ESC pressionado
            elif tecla == b'q':
                camera.release()
                cv2.destroyAllWindows()
                break
    except:
        print("error in key")