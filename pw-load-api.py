#! C:/Python38/python.exe
# print("Content-Type: text/html\n")

import json, duolingo
from datetime import datetime

duo_user = duolingo.Duolingo('lidiaCirrone', 'hyaB_3cQN-ei')
user_fields = ['courses','creationDate','id','learningLanguage','totalXp','trackingProperties']
user_total_info = duo_user.get_data_by_user_id(user_fields)

username = user_total_info['trackingProperties']['username']
userid = user_total_info['id']
learning_language_abbr = user_total_info['learningLanguage']

user_date_timestamp = user_total_info['creationDate']
user_date_str = datetime.fromtimestamp(user_date_timestamp).strftime("%d/%m/%Y")

language_progress = duo_user.get_language_progress(learning_language_abbr)
current_languages = duo_user.get_languages(abbreviations=True)

user_object = {
    'username': username,
    'streak': language_progress['streak'],
    'xp': user_total_info['totalXp'],
    'creation_date': user_date_str,
    'learning_language': {
        'string': language_progress['language_string'],
        'level': language_progress['level'],
        'level_percent': language_progress['level_percent']
    },
    'current_languages': current_languages
}

print(json.dumps(user_object))