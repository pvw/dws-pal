#!/usr/bin/env python
# encoding: utf-8

import sys, os, hashlib, subprocess


'''
Generate new content.

1.  Handle bundles file elements
    1.1 Combine files into one bundle file
    1.2 Persist to disk since the YUI compressor need a file
    1.3 Compressing using YUI Compress
    1.4 Move file to build
    1.5 If css bundle create a raw file for devlopment
'''
def generate():
    cwd = os.path.abspath(os.path.dirname(__file__))
    try:
        from asset_bundles import ASSET_BUNDLES
    except Exception, e:
        print e.message
        return False
        
    cwd = os.path.abspath(os.path.dirname(__file__))
    BUNDLE_MAP = {} # Used to persist asset budle hashes
    
    # 1. Handle each bundles file element
    for bundle in ASSET_BUNDLES:
        file_contents = ''
        raw_file_contents = ''
        path = ASSET_BUNDLES[bundle]['path']

        # 1.1 Combine files into one bundle file
        for file_element in ASSET_BUNDLES[bundle]['files']:
            try:
                file_path = path + 'src/' + file_element
                source_file = open('%s/../../%s' % (cwd,file_path) )
                tmp = source_file.read()
                source_file.close()                
                file_contents = '%s\n\n/*%s\n Contents from: %s\n%s*/\n\n%s' % (file_contents, 75*'-', file_element, 75*'-', tmp)
                if ASSET_BUNDLES[bundle]['type'] == 'css':
                    raw_file_contents = '%s@import url("%s%s");\n' % (raw_file_contents, '../src/', file_element)
            except Exception, e:
                print 'Could not find bundle source file: %s' % file_element
                raise e

        # 1.2 Persist to disk since the YUI compressor need a file
        bundle_file_path = '%s/../../%ssrc/%s.%s' % (cwd, path, bundle, ASSET_BUNDLES[bundle]['type'])
        bundle_file = open(bundle_file_path,"w")
        bundle_file.write(file_contents)
        bundle_file.close()
        
        # 1.3 Compressing using YUI Compress. We are using --preserve-semi to be JSLint compatible
        if ASSET_BUNDLES[bundle]['compress'] == True:
            try:
                compressor_string = 'java -jar %s/yuicompressor-2.4.2.jar %s --charset utf-8 --preserve-semi -o %s' % (cwd,bundle_file_path,bundle_file_path)
                retcode = subprocess.call(compressor_string, shell=True)
                if retcode < 0:
                    print >>sys.stderr, "Yuicompressor was terminated by signal", -retcode
            except OSError, e:
                print 'Problem with running the YUICompressor. Got error: %s' % e
                raise e

        # 1.4 Move file to build
        try:
            mv_string = 'mv %s %s/../../%sbuild/%s.%s' % (bundle_file_path, cwd, ASSET_BUNDLES[bundle]['path'], bundle, ASSET_BUNDLES[bundle]['type'])
            retcode = subprocess.call(mv_string, shell=True)
            if retcode < 0:
                print >>sys.stderr, "Could not move (rename) the bundle file, Move was terminated by signal", -retcode
        except OSError, e:
            print 'Could not add hash to file name, Got error: %s' %e
            raise e
        
        
        # 1.5 If css bundle create a raw file for devlopment
        if ASSET_BUNDLES[bundle]['type'] == 'css':
            try:
                raw_file_path = '%s/../../%sbuild/%s_raw.css' % (cwd, path, bundle,)
                raw_file = open(raw_file_path,"w")
                raw_file.write(raw_file_contents)
                raw_file.close()
            except Exception, e:
                print 'Could not write raw file'
            
            try:
                git_add_raw_file_string = 'git add %s' % raw_file_path
                retcode = subprocess.call(git_add_raw_file_string, shell=True)
                if retcode < 0:
                    print >>sys.stderr, "Could add raw file to the git index, Git add was terminated by signal", -retcode
            except OSError, e:
                print 'Could not add the new raw file to git. Got error: %s' % e
        
        print '%s packed!' % bundle

    return True


def main():
    print 'Running packer...'
    
    # Generate new files (asset bundle files and map file)
    if not generate():
        print 'Generator could not find a asset_bundle file'
        
    return True
    
if __name__ == '__main__':
	main()