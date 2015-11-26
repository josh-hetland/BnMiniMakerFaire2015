#!/usr/bin/python

import RPi.GPIO as GPIO
import time
import gpio_client

try:
    GPIO.setmode(GPIO.BOARD)

    #actually this should prompt for what they are
    #name, pin, value?
    Upstairs    = { 'Pin' : None, 'State' : False }
    Downstairs  = { 'Pin' : None, 'State' : False }
    Outside     = { 'Pin' : None, 'State' : False }
    
    Upstairs['Pin'] = int(raw_input('Enter upstairs pin:'))
    if Upstairs['Pin'] != None:
        GPIO.setup( Upstairs['Pin'], GPIO.OUT )
        GPIO.output( Upstairs['Pin'], False )
        
    Downstairs['Pin'] = int(raw_input('Enter downstairs pin:'))
    if Downstairs['Pin'] != None:
        GPIO.setup( Downstairs['Pin'], GPIO.OUT )
        GPIO.output( Downstairs['Pin'], False )
        
    Outside['Pin'] = int(raw_input('Enter outside pin:'))
    if Outside['Pin'] != None:
        GPIO.setup( Outside['Pin'], GPIO.OUT )
        GPIO.output( Outside['Pin'], False )
    
    while True:
        #Value = int(raw_input('Toggle Upstairs[1], Downstairs[2], Outside[3]:'))
        Value = gpio_client.checkin( Upstairs['State'], Downstairs['State'], Outside['State'] )

        if Value != -1:
            print("new request from server [ %d ]" % Value )
        
        if Value == 1:
            if Upstairs['Pin'] != None:
                Upstairs['State'] = False if Upstairs['State'] else True
                GPIO.output( Upstairs['Pin'], Upstairs['State'] )
        elif Value == 2:
            if Downstairs['Pin'] != None:
                Downstairs['State'] = False if Downstairs['State'] else True
                GPIO.output( Downstairs['Pin'], Downstairs['State'] )
        elif Value == 3:
            if Outside['Pin'] != None:
                Outside['State'] = False if Outside['State'] else True
                GPIO.output( Outside['Pin'], Outside['State'] )
        elif Value == 4:
            break
                
finally:
    GPIO.cleanup()
    
