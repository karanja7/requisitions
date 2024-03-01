
import cv2
import numpy as np
import tensorflow as tf
from keras.models import load_model
from deepface import DeepFace


img = cv2.imread("sample.jpg")
gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

# Create a face detector object and load the haarcascade file
face_detector = cv2.CascadeClassifier("haarcascade_frontalface_default.xml")

faces = face_detector.detectMultiScale(gray, 1.3, 5)

# For each face, crop the face region, analyze the emotion, and draw the bounding box and label
for (x, y, w, h) in faces:
    
    face = img[y:y+h, x:x+w]
    
    emotion = DeepFace.analyze(face, actions=["emotion"])
    
    emotion_label = emotion["dominant_emotion"]
    emotion_score = emotion["emotion"][emotion_label]
    
    cv2.rectangle(img, (x, y), (x+w, y+h), (0, 255, 0), 2)
    cv2.putText(img, emotion_label + " " + str(round(emotion_score, 2)), (x, y-10), cv2.FONT_HERSHEY_SIMPLEX, 0.7, (0, 255, 0), 2)


cv2.imshow("Face and Emotion Detection", img)
cv2.waitKey(0)
cv2.destroyAllWindows()
# cv2.imwrite("result.jpg", img)
