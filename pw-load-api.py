#! C:/Python38/python.exe
# print("Content-Type: text/html\n")

import json, duolingo
from datetime import datetime
from settings import duo_user_name, duo_user_password

duo_user = duolingo.Duolingo(duo_user_name, duo_user_password)
user_fields = ['courses','creationDate','id','learningLanguage', 'picture','totalXp','trackingProperties']
user_total_info = duo_user.get_data_by_user_id(user_fields)

username = user_total_info['trackingProperties']['username']
userid = user_total_info['id']
avatar = f"{user_total_info['picture']}/xlarge"
learning_language_abbr = user_total_info['learningLanguage']

user_date_timestamp = user_total_info['creationDate']
user_date_str = datetime.fromtimestamp(user_date_timestamp).strftime("%d/%m/%Y")

language_progress = duo_user.get_language_progress(learning_language_abbr)

all_languages = {}
for language in user_total_info['courses']:
   target = language['learningLanguage']
   source = language['fromLanguage']
   # xp = language['xp']
   # crowns = language['crowns']
   if source not in all_languages:
      all_languages[source] = []
   all_languages[source].append(target)
   # all_languages[source][target] = {
   #    'xp': xp,
   #    'crowns': crowns
   #    }


user_object = {
    'avatar': avatar,
    'username': username,
    'streak': language_progress['streak'],
    'xp': user_total_info['totalXp'],
    'creation_date': user_date_str,
    'learning_language': {
        'string': language_progress['language_string'],
        'level': language_progress['level'],
        'level_percent': language_progress['level_percent']
    },
    'all_languages': all_languages
}

print(json.dumps(user_object))