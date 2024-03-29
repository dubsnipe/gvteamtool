# GV Team Tool

## Description

This is a tool written for Habitat for Humanity Global Village coordinators. It was created for managing team data on a local server or online. This tool will give you the ability to record basic trip information and other metadata in order to have a detailed database of teams, volunteers and related information, as well as to generate reports based on available data.

For example, I used R to download team and volunteer participation data from the server and created a report for over 20 years of Global Village in El Salvador. I may link to it in a future version, or you can contact me with any of your questions.

## Features

### Dashboard

![Screenshot 01](/docs/screenshots/01.png)

### Team calendar

![Screenshot 03](/docs/screenshots/03.png)

### Team registry with various metadata fields

![Screenshot 06](/docs/screenshots/06.png)

### Volunteer tracking and their volunteer engagement history.

![Screenshot 02](/docs/screenshots/02.png)

### Advanced search of teams by GV code, dates of trip and status (active/cancelled), and of volunteers by name, email address or location.
![Screenshot 04](/docs/screenshots/04.png)

### Report generation can be limited by date, type of team or name of team.
![Screenshot 05](/docs/screenshots/05.png)

# Project status

This repo is intended to share work with all HFH GV Hosting Teams that need a tool to record and manage their team participation. For the moment no update is intended from my side since I am leaving the organization, so I encourage you to invite developers to work with you on this project forking or pushing some of your updates to this repo for the benefit of the community.

## Bugs or issues to solve

- User management module: user permissions are hardcoded for now and are still not closed to other users.
- Security management: Due to time, I haven't solved cookie expiration and other security issues.
- Structure: certain tables (officers, translators, regions, projects) are only for use in selection, and not relational.
- Visualizations: reports are just a test at most. Some maps and charts were created by using D3 just to test it out.
- Localization: some parts of the code will have to be edited to fit your country or language.
- Redundancy: filters or ability to merge in order to prevent data redundancy (this could've been useful mostly for legacy data).

# Installation

1. Install it as a [CakePHP](https://getcomposer.org/doc/00-intro.md) 3.6 dependency.
2. Copy the contents of this repo and install as a project.
3. Install the required external packages.

## Required Packages

- [Imagine](https://imagine.readthedocs.io/en/stable/usage/introduction.html#installation)
- [cakephp-upload](http://josediazgonzalez.com/2015/12/05/uploading-files-and-images/)
- [cakephp-csvview](https://packagist.org/packages/friendsofcake/cakephp-csvview)
- [CakePHP Search](https://github.com/friendsofcake/search)
- [Trash](https://github.com/UseMuffin/Trash)

# Thanks

- I thank HFH GV Hosts for their hard work.
- Luis Viscarra (HFH El Salvador Hosting Coordinator) for allowing me to allot time to develop this tool.
- Adriana Peña from HFH El Salvador and volunteers like Francia Ochoa, Gabriela, Christian, Rosana and Mauricio for their work adding data, beta testing and giving advice on how to build it.
- The Open Source Communities of CakePHP and all the people at Stack Overflow whose code I blatantly stole. You rock.

# License
```
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions: 

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
```

Short version: 
- This is open for anyone to play, install or modify as they wish. 
- If you make something new, you are forced to share by using the same license.
- We encourage you to share your development with others. 
- Don't complain if it doesn't work; support the community in improving it.