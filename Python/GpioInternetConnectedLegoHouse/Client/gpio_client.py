#!/usr/bin/python

import urllib3
import json

def checkin( upstairs, downstairs, outside ):
	if not hasattr(checkin, 'connection'):
		checkin.connection = urllib3.PoolManager()
		
		
	if upstairs == True:
		upstairs = 1
	else:
		upstairs = 0
	if downstairs == True:
		downstairs = 1
	else:
		downstairs = 0
	if outside == True:
		outside = 1
	else:
		outside = 0
		url = 'http://www.hetland.ws/make/lib/Worker.Service.php'
		values = { 'Upstairs' : upstairs, 'Downstairs' : downstairs, 'Outside' : outside }
		response = checkin.connection.request( 'POST', url, values )
		result = json.loads( response.data )
		
		
	if result['Room'] == 'upstairs':
		return 1
	elif result['Room'] == 'downstairs':
		return 2
	elif result['Room'] == 'outside':
		return 3
	else:
		return -1


if __name__ == '__main__':
	next_request = checkin( 0, 0 , 0 )
	print( 'Value [ %d ] returned from server' % next_request )
